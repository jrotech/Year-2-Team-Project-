import scrapy


class CPUSpider(scrapy.Spider):
    name = "CPUSpider"
    allowed_domains = ["scan.co.uk"]
    

    def parse(self, response):
        pass
