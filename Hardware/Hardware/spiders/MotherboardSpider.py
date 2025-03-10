import scrapy
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
from Hardware.items import MotherboardItem
from Hardware.loaders import MotherboardLoader
import json

class MotherboardSpider(scrapy.Spider):
    name = "MotherboardSpider"
    allowed_domains = ["quotes.toscrape.com"]

    def load_product_links(self):
        try:
            with open("C:\\Users\\jacob\\OneDrive - Aston University\\Programming\\Python\\HardwareSpiders\\Hardware\\newlinks.json", "r") as file:
                data = json.load(file)  # Ensure newlinks.json contains a list of dicts with "category" and "link"
                return [item["link"] for item in data if item.get("category") == "Motherboard"]
        except Exception as e:
            self.logger.error(f"Error loading newlinks.json: {e}")
            return []
        
        
        
        
    def __init__(self):
        # Set up Selenium WebDriver
        chrome_service = Service(ChromeDriverManager().install())
        options = Options()
        options.add_argument("--disable-gpu")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        options.add_argument("--disable-blink-features=AutomationControlled")
        self.driver = webdriver.Chrome(service=chrome_service, options=options)

    def start_requests(self):
        motherboard_links =  self.load_product_links() 

        for url in motherboard_links:
            self.driver.get(url)
            rendered_source = self.driver.page_source
            selector = scrapy.Selector(text=rendered_source)
            yield scrapy.Request("https://quotes.toscrape.com/",callback=self.parse,meta={"rendered_selector": selector, "url": url},dont_filter=True)
    

    def parse(self, response):
        #handles both variant list pages and individual CPU product pages
        selector = response.meta["rendered_selector"]
        

         #individual product page, use CPULoader to extract details
        loader = MotherboardLoader(item=MotherboardItem(), selector=selector)

        # Extract Title
        title = selector.css("#oopStage-title span::text").getall()
        full_title = " ".join(title).strip() if title else None

       
        loader.add_value("name", full_title)

         # Extract Description
        description_items = selector.css(".oopStage-productInfoTopItemWrapper .oopStage-productInfoTopItem::text").getall()
        description = " | ".join(desc.strip() for desc in description_items)
        loader.add_value("description", description)

         # Extract Image URLs
        image_links = selector.css(".simple-carousel-thumbnails img::attr(src)").getall()
        # We'll let the loader's MapCompose(fix_image_scheme) handle the scheme
        loader.add_value("image_links", image_links)

        # Extract Price
        price = selector.css(".productOffers-listItemOfferPrice::text").get()
        if price:
            loader.add_value("price", price.strip())

        ## extract tdp, socket type and integrated graphics
        table_rows = selector.css("table.datasheet-list tr")  # Select all table rows
        
        for row in table_rows:
            row_title = row.css("td:nth-child(1)::text").get()
            row_value = row.css("td:nth-child(2)::text").get()
  
            row_title = row_title.strip() if row_title else None
            row_value = row_value.strip() if row_value else None

            if row_title == "CPU Socket":
                loader.add_value("socket_type", row_value)
            elif row_title == "RAM Type":
                loader.add_value("ram_type", row_value)
            elif row_title == "Storage Connectors":
                loader.add_value("SATA_storage_connectors", row_value)
                loader.add_value("M2_storage_connectors", row_value)
        

        yield loader.load_item()
