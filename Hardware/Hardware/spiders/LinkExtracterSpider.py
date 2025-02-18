import scrapy
from items import LinkItem

class LinkextracterspiderSpider(scrapy.Spider):
    name = "LinkExtracterSpider"
    allowed_domains = ["www.scan.co.uk"]
    start_urls = ["https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/all"]
    categories = {
    "https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/all": "CPU",
    "https://www.scan.co.uk/shop/computer-hardware/cpu-intel-desktop/all": "CPU",
    "https://www.scan.co.uk/shop/computer-hardware/gpu-amd-gaming/all": "GPU",
    "https://www.scan.co.uk/shop/computer-hardware/gpu-nvidia-gaming/all": "GPU",
    "https://www.scan.co.uk/shop/computer-hardware/hard-drives-internal/all": "Storage",
    "https://www.scan.co.uk/shop/computer-hardware/solid-state-drives/all": "Storage",
    "https://www.scan.co.uk/shop/computer-hardware/motherboards-amd/all": "Motherboard",
    "https://www.scan.co.uk/shop/computer-hardware/motherboards-intel/all": "Motherboard",
    "https://www.scan.co.uk/shop/computer-hardware/power-supplies/all": "PSU",
    "https://www.scan.co.uk/shop/computer-hardware/memory-ram/all": "RAM",
    "https://www.scan.co.uk/shop/computer-hardware/cooling-air/all": "Cooling",
}
    def parse(self, response):
        
        category = response.css('div.category')
        for cat in category:
            ulist = cat.css("ul.product-group")
            for ul in ulist:
                for li in ul.css("li.product"):
                    linkitem = LinkItem()
                    linkitem["link"] = li.css("a::attr(href)").get()
                    linkitem["category"] = self.categories[response.url]
                    yield linkitem