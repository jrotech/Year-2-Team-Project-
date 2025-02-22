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
            data = json.load(f)
        cpulinks =[]
        for key in data:
            if data[key] == "CPU":
                cpulinks.append(key)
        for link in cpulinks:
            full_url = f"https://www.scan.co.uk{link}"
            yield scrapy.Request(url=full_url, callback=self.parse)