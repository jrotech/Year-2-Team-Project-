import scrapy
import time
import random
from scrapy.loader import ItemLoader
from Hardware.items import CPUItem
from Hardware.loaders import CPULoader
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options

from webdriver_manager.chrome import ChromeDriverManager

import json

class CPUSpider(scrapy.Spider):
    name = "CPUSpider"
    allowed_domains = ["scan.co.uk"]
    
    def __init__(self):
        # initialize the webdriver
        chrome_service = Service(ChromeDriverManager().install())
        options = webdriver.ChromeOptions()
        options.add_argument("--headless")  # Run headless to avoid opening a browser window
        options.add_argument("--disable-gpu")
        options.add_argument("--no-sandbox")
        options.add_argument("--disable-dev-shm-usage")
        
        self.driver = webdriver.Chrome(service=chrome_service, options=options)
    def start_requests(self):
        json_file = "links.json"
        with open(json_file, "r", encoding="utf-8") as f:
            data = json.load(f)     #list of dictionaries

        cpulinks =[]
        for item in data: 
            if item["category"] == "CPU":  
                cpulinks.append(item["link"])  

        for link in cpulinks:
            full_url = f"https://www.scan.co.uk{link}"
            #self.driver.get(full_url)
            #response = scrapy.Selector(text=self.driver.page_source)
            #yield scrapy.Request(full_url, callback=self.parse, meta={"response": response})
            yield scrapy.Request(full_url, callback=self.parse)

    def parse(self, response):
        loader = CPULoader(item=CPUItem(), response=response)

        loader.add_css("name", "h1::text")
        loader.add_css("price", "div.product-prices span.price *::text")  # "*" to get all text nodes inside
        loader.add_css("description", "p.sectionText::text") # the loader will extract the first paragraph only

        spec_rows = response.css("div.specifications table tr") #all table rows
        for row in spec_rows:
            key = row.css("td:first-child::text").get("")
            value = row.css("td:last-child::text").get("")

            if "Socket" in key:
                loader.add_value("socket_type", value)
            elif "TDP" in key or "Power" in key:
                loader.add_value("tdp", value)
            elif "Integrated Graphics" in key or "Graphics" in key:
                loader.add_value("integrated_graphics", value)

        # Extract image URLs
        image_urls = response.css("div.thumbnails img::attr(src)").getall()
        loader.add_value("image_urls", [f"https:{img}" for img in image_urls[:4]])

        # Add URL
        loader.add_value("url", response.url)
        yield loader.load_item()
    def closed(self, reason):
        self.driver.quit()