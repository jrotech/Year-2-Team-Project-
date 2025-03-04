import scrapy
import time
from Hardware.items import LinkItem
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.chrome.options import Options
from webdriver_manager.chrome import ChromeDriverManager

class LinkExtracterSpider(scrapy.Spider):
    name = "LinkExtracterSpider"
    allowed_domains = ["idealo.co.uk", "quotes.toscrape.com"]

    start_urls = ["https://www.idealo.co.uk/cat/3019/cpus.html",
                  "https://www.idealo.co.uk/cat/3019I16-15/cpus.html",
                  "https://www.idealo.co.uk/cat/16073/graphics-cards.html",
                  "https://www.idealo.co.uk/cat/16073I16-15/graphics-cards.html",
                  "https://www.idealo.co.uk/cat/14613/ssd.html",
                  "https://www.idealo.co.uk/cat/3011/hard-drives.html",
                  "https://www.idealo.co.uk/cat/3018/motherboards.html",
                  "https://www.idealo.co.uk/cat/3018I16-15/motherboards.html",
                  "https://www.idealo.co.uk/cat/4552/ram.html",
                  "https://www.idealo.co.uk/cat/5432/psus.html",
                  "https://www.idealo.co.uk/cat/5432I16-15/psus.html",
                  "https://www.idealo.co.uk/cat/5156F5259177/cpu-fans.html"
                  ]

    categories = {
        "https://www.idealo.co.uk/cat/3019/cpus.html": "CPU",
        "https://www.idealo.co.uk/cat/3019I16-15/cpus.html": "CPU",
        "https://www.idealo.co.uk/cat/16073/graphics-cards.html": "GPU",
        "https://www.idealo.co.uk/cat/16073I16-15/graphics-cards.html": "GPU",
        "https://www.idealo.co.uk/cat/14613/ssd.html": "Storage",
        "https://www.idealo.co.uk/cat/3011/hard-drives.html": "Storage",
        "https://www.idealo.co.uk/cat/3018/motherboards.html": "Motherboard",
        "https://www.idealo.co.uk/cat/3018I16-15/motherboards.html": "Motherboard",
        "https://www.idealo.co.uk/cat/4552/ram.html": "RAM",
        "https://www.idealo.co.uk/cat/5432/psus.html": "PSU",
        "https://www.idealo.co.uk/cat/5432I16-15/psus.html": "PSU",
        "https://www.idealo.co.uk/cat/5156F5259177/cpu-fans.html": "CPU Fan"
    }

    def __init__(self):
        # Set up Selenium WebDriver
        chrome_service = Service(ChromeDriverManager().install())
        options = Options()
        options.add_argument("--disable-gpu")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        options.add_argument("--disable-blink-features=AutomationControlled")
        # Feel free to add/change arguments (e.g., user-agent) as needed

        self.driver = webdriver.Chrome(service=chrome_service, options=options)

    def start_requests(self):
        """Use Selenium to visit the start URL(s) and then create a Scrapy request from the page source."""
        for url in self.start_urls:
            self.driver.get(url)
            # Give the page time to render dynamically

            # Grab the rendered page source and convert it to a Scrapy selector
            rendered_source = self.driver.page_source
            selector = scrapy.Selector(text=rendered_source)

            # Pass the selector through meta so it can be used in parse()
            yield scrapy.Request("https://quotes.toscrape.com/", callback=self.parse, meta={"rendered_selector": selector, "url": url},dont_filter=True)

    def parse(self, response):
        selector = response.meta["rendered_selector"]
        product_blocks = selector.css("div.sr-resultList__item_m6xdA")

        for block in product_blocks:
            product_link = block.css("div.sr-resultItemLink_YbJS7 a[data-testid='link']::attr(href)").get()
            price_text = block.css("div.sr-detailedPriceInfo__price_sYVmx::text").get(default="").strip()

            link_item = LinkItem()
            link_item["link"] = product_link
            link_item["category"] = self.categories.get(response.meta["url"], "Unknown")
            link_item["price"] = price_text
            if product_link is not None:
                yield link_item

    def closed(self, reason):
        """Close the Selenium browser once the spider finishes or is stopped."""
        self.driver.quit()
