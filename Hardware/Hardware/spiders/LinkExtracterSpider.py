import scrapy


class LinkextracterspiderSpider(scrapy.Spider):
    name = "LinkExtracterSpider"
    allowed_domains = ["www.scan.co.uk"]
    start_urls = ["https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/all"]
    
    def parse(self, response):
        
        category = response.css('div.category')
        for cat in category:
            ulist = cat.css("ul.product-group")
            for ul in ulist:
                for li in ul.css("li.product"):
                    yield {
                        "link": li.css("a.image::href").extract_first()
                    }
        