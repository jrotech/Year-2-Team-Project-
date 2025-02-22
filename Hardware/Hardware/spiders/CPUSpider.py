import scrapy
from scrapy.loader import ItemLoader
from Hardware.items import CPUItem
from Hardware.loaders import CPULoader
import json

class CPUSpider(scrapy.Spider):
    name = "CPUSpider"
    allowed_domains = ["scan.co.uk"]
    

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
            yield scrapy.Request(url=full_url, callback=self.parse)


    def parse(self, response):
        loader = CPULoader(item=CPUItem(), response=response)

        loader.add_css("name", "h1::text")
        loader.add_css("price", "div.price-rating-bar div.product-prices span.price::text")
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