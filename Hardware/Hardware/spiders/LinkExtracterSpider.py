import scrapy
import math
from Hardware.items import LinkItem

class LinkextracterspiderSpider(scrapy.Spider):
    name = "LinkExtracterSpider"
    allowed_domains = ["www.scan.co.uk"]
    start_urls = ["https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/3843/3842/3275/3925/3926/3927/3645/3644/3643/3198/3197/3196/3591/3590/3864/3865",
    "https://www.scan.co.uk/shop/computer-hardware/cpu-intel-desktop/3090/3866/3814/3667/3463/3464/3668/3815/3816/3669/3465/3527/3736",
    "https://www.scan.co.uk/shop/computer-hardware/gpu-amd-gaming/3714/3713/3880/3810/3809/3872/3786/3219/3218/3217/3600/3601/3473/3550",
    "https://www.scan.co.uk/shop/computer-hardware/gpu-nvidia-gaming/4039/4036/4040/4041/3646/3863/3862/3715/3861/3767/3801/3780/3787/3175/3176/3177/3257/3543/3875/3506/2192",
    "https://www.scan.co.uk/shop/computer-hardware/hard-drives-internal/2614/837/2612/2613/166",
    "https://www.scan.co.uk/shop/computer-hardware/solid-state-drives/2627/2375/2628/3765/3049/3841/698/2630/1766/2632",
    "https://www.scan.co.uk/shop/computer-hardware/motherboards-amd/3847/3846/3276/3941/3944/3946/3660/3662/3657/4024/4025/4026/4027/4028/4029/3679/3680/3681/3772/3131/3132/3133/2760",
    "https://www.scan.co.uk/shop/computer-hardware/motherboards-intel/3990/3991/3992/4032/4031/4030/4048/4049/4050/3672/3671/3670/3724/3725/3726",
    "https://www.scan.co.uk/shop/computer-hardware/power-supplies/1278/814/2373/2372",
    "https://www.scan.co.uk/shop/computer-hardware/memory-ram/4020/3953/3676/3952/3675/2571/2056/1955/2572/3490/1949",
    "https://www.scan.co.uk/shop/computer-hardware/cooling-air/231/232"]


    categories = {
    "https://www.scan.co.uk/shop/computer-hardware/cpu-amd-desktop/3843/3842/3275/3925/3926/3927/3645/3644/3643/3198/3197/3196/3591/3590/3864/3865": "CPU",
    "https://www.scan.co.uk/shop/computer-hardware/cpu-intel-desktop/3090/3866/3814/3667/3463/3464/3668/3815/3816/3669/3465/3527/3736": "CPU",
    "https://www.scan.co.uk/shop/computer-hardware/gpu-amd-gaming/3714/3713/3880/3810/3809/3872/3786/3219/3218/3217/3600/3601/3473/3550": "GPU",
    "https://www.scan.co.uk/shop/computer-hardware/gpu-nvidia-gaming/4039/4036/4040/4041/3646/3863/3862/3715/3861/3767/3801/3780/3787/3175/3176/3177/3257/3543/3875/3506/2192": "GPU",
    "https://www.scan.co.uk/shop/computer-hardware/hard-drives-internal/2614/837/2612/2613/166": "Storage",
    "https://www.scan.co.uk/shop/computer-hardware/solid-state-drives/2627/2375/2628/3765/3049/3841/698/2630/1766/2632": "Storage",
    "https://www.scan.co.uk/shop/computer-hardware/motherboards-amd/3847/3846/3276/3941/3944/3946/3660/3662/3657/4024/4025/4026/4027/4028/4029/3679/3680/3681/3772/3131/3132/3133/2760": "Motherboard",
    "https://www.scan.co.uk/shop/computer-hardware/motherboards-intel/3990/3991/3992/4032/4031/4030/4048/4049/4050/3672/3671/3670/3724/3725/3726": "Motherboard",
    "https://www.scan.co.uk/shop/computer-hardware/power-supplies/1278/814/2373/2372": "PSU",
    "https://www.scan.co.uk/shop/computer-hardware/memory-ram/4020/3953/3676/3952/3675/2571/2056/1955/2572/3490/1949": "RAM",
    "https://www.scan.co.uk/shop/computer-hardware/cooling-air/231/232": "Cooling",
    }
    def parse(self, response):
        category_divs = response.css("div.category")
        
        # count only non-empty categories
        non_empty_categories = [cat for cat in category_divs if cat.css("ul.product-group li.product")]
        num_categories = len(non_empty_categories)

        if num_categories == 0: 
            return

        # products to take per item type
        total_products_target = 30  
        products_per_category_gen = max(math.ceil(total_products_target / num_categories), 3)  

        self.logger.info(f"Found {num_categories} non-empty categories, extracting {products_per_category_gen} products per category.")

        for cat in non_empty_categories:
            product_list = cat.css("ul.product-group li.product") 
            extracted_count = 0  
            products_per_category = products_per_category_gen
            for li in product_list:
                # "Notify Me" instead of a price
                has_notify_me = li.css("div.notify-when-in-stock").get() is not None
                
                if has_notify_me:
                    products_per_category += 1  # increase the limit to get a replacement product
                    continue  # skip
                
                linkitem = LinkItem()
                linkitem["link"] = li.css("a::attr(href)").get()
                linkitem["category"] = self.categories[response.url]
                
                yield linkitem
                extracted_count += 1
                if extracted_count >= products_per_category:
                    break