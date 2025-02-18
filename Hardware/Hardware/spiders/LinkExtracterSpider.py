import scrapy


class LinkextracterspiderSpider(scrapy.Spider):
    name = "LinkExtracterSpider"
    allowed_domains = ["www.scan.co.uk"]
    start_urls = ["https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/all"]
    categories = {
        "CPU": "https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/all",
        "CPU": "https://www.scan.co.uk/shop/computer-hardware/cpu-intel-desktop/all",
        "GPU": "https://www.scan.co.uk/shop/computer-hardware/gpu-amd-gaming/all",
        "GPU": "https://www.scan.co.uk/shop/computer-hardware/gpu-nvidia-gaming/all",
        "Storage": "https://www.scan.co.uk/shop/computer-hardware/hard-drives-internal/all",
        "Storage": "https://www.scan.co.uk/shop/computer-hardware/solid-state-drives/all",
        "Motherboard": "https://www.scan.co.uk/shop/computer-hardware/motherboards-amd/all",
        "Motherboard": "https://www.scan.co.uk/shop/computer-hardware/motherboards-intel/all",
        "PSU": "https://www.scan.co.uk/shop/computer-hardware/power-supplies/all",
        "RAM": "https://www.scan.co.uk/shop/computer-hardware/memory-ram/all",
        "Cooling": "https://www.scan.co.uk/shop/computer-hardware/cooling-air/all",
        }
    def parse(self, response):
        
        category = response.css('div.category')
        for cat in category:
            ulist = cat.css("ul.product-group")
            for ul in ulist:
                for li in ul.css("li.product"):
                    yield {
                        "link": li.css("a.image::attr(href)").get()
                    }
        