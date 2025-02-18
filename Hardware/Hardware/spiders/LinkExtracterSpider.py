import scrapy


class LinkextracterspiderSpider(scrapy.Spider):
    name = "LinkExtracterSpider"
    allowed_domains = ["www.scan.co.uk"]
    start_urls = ["https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/all"]

    def parse(self, response):
        pass