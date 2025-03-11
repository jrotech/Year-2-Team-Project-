import scrapy
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager
from Hardware.items import StorageItem
from Hardware.loaders import StorageLoader
import json

class StoragespiderSpider(scrapy.Spider):
    name = "StorageSpider"
    allowed_domains = ["quotes.toscrape.com"]
    def load_product_links(self):
        try:
            with open("C:\\Users\\jacob\\OneDrive - Aston University\\Programming\\Python\\HardwareSpiders\\Hardware\\fruits\\newlinks.json", "r") as file:
                data = json.load(file)  # Ensure newlinks.json contains a list of dicts with "category" and "link"
                return [item["link"] for item in data if item.get("category") == "Storage"]
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
        storage_links =  self.load_product_links() 

        for url in storage_links:
            self.driver.get(url)
            rendered_source = self.driver.page_source
            selector = scrapy.Selector(text=rendered_source)

            yield scrapy.Request("https://quotes.toscrape.com/",callback=self.parse,meta={"rendered_selector": selector, "url": url},dont_filter=True)
    


    def parse(self, response):
        #handles both variant list pages and individual Stoage product pages
        selector = response.meta["rendered_selector"]
        

         #individual product page, use Storageloader to extract details
        loader = StorageLoader(item=StorageItem(), selector=selector)

        # Extract Title
        title = selector.css("#oopStage-title span::text").getall()
        full_title = " ".join(title).strip() if title else None

        variants = selector.css(".productVariants-listItemWrapper::attr(href)").getall()
     
        if variants:
            for variant in variants:
                newurl = "https://www.idealo.co.uk/"+ variant
                self.driver.get(newurl)
                rendered_source = self.driver.page_source
                selector = scrapy.Selector(text=rendered_source)
                yield scrapy.Request(
                    "https://quotes.toscrape.com/",
                    callback=self.parse,
                    meta={"rendered_selector": selector, "url": newurl},
                    dont_filter=True
                )
            return  # stop there
        
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

        ## extract tdp, socket type and integrated graphics + specs
        table_rows = selector.css("table.datasheet-list tr")  # Select all table rows
        table_data ={}
        current_header ="Name"
        table_data[current_header] = {}
        for row in table_rows:

            if row.css("th::text").get():
                current_header = row.css("th::text").get().strip()
                table_data[current_header] = {}
            else:
                row_title = row.css("td:nth-child(1)::text").get()
                row_value = row.css("td:nth-child(2)::text").get()
    
                row_title = row_title.strip() if row_title else None
                row_value = row_value.strip() if row_value else None

                table_data[current_header][row_title] = row_value
                
                if row_title.upper() == "BUS" and "SATA" in row_value:
                    loader.add_value("connector_type", "SATA")
                if row_title == "Form Factor" and row_value == "M.2":
                    loader.add_value("connector_type", "M.2")
                
        json_table = json.dumps(table_data,ensure_ascii=False)
        loader.add_value("specifications", json_table)

        yield loader.load_item()

