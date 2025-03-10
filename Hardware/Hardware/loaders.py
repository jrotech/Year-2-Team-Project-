from scrapy.loader import ItemLoader
from itemloaders.processors  import TakeFirst, MapCompose, Join, Identity
import re

def clean_price(value):
    price_str = value.replace("£", "").replace(",", "").strip()  
    return price_str

def clean_text(value):
    return value.strip()
def extract_cpu_tdp(value):
    #regex for '350W' -> '350'
    match = re.search(r"(\d+)\s*W", value)
    return match.group(1) if match else value
def  hasGraphics(value):
    return False if "N/A" in value else True

class CPULoader(ItemLoader):
    default_output_processor = TakeFirst()  

    name_in = MapCompose(clean_text)
    price_in = MapCompose(clean_price)
    price_out = Join()
    description_in = MapCompose(clean_text)
    socket_type_in = MapCompose(clean_text)
    tdp_in = MapCompose(clean_text, extract_cpu_tdp)  
    integrated_graphics_in = MapCompose(clean_text, hasGraphics)
    image_urls_out = Join(",")  # Joins list of image URLs into a string

def fix_image_scheme(img_url):
    """Converts //cdn... => https://cdn... to avoid missing scheme errors."""
    img_url = img_url.strip()
    if img_url.startswith("//"):
        img_url = "https:" + img_url
    return img_url
def enhance_image(img_url):
    img_url = img_url.replace("klein","max")
    return img_url
def clean_description(description):
    for char in description:
        if char.isspace():
            description = description.replace(char, " ")
    return description
def define_gpu_tdp(title):
    gpu_tdp_dict = {
    "RX 7900 XTX": 355,
    "RX 7900 XT": 315,
    "RX 6950 XT": 335,
    "RX 6900 XT": 300,
    "RX 6800 XT": 300,
    "RX 6800": 250,
    "RX 6750 XT": 250,
    "RX 6700 XT": 160,
    "RX 6650 XT": 180,
    "RX 6600 XT": 160,
    "RX 6600": 132,
    "RX 6500 XT": 107,
    "RX 6400": 53,
    "RX 5700 XT": 225,
    "RX 5600 XT": 160,
    "RX 5500 XT": 130,
    "RX 580": 185,
    "RX 570": 150,
    "RX 9070 XT" : 320,
    "RX 9070" : 280,
    "RTX 5090": 575,
    "RTX 5080": 360,
    "RTX 5070 Ti": 300,
    "RTX 5070": 250,
    "RTX 4090": 450,
    "RTX 4080 Super": 320,
    "RTX 4080": 320,
    "RTX 4070 Ti Super": 285,
    "RTX 4070 Ti": 285,
    "RTX 4070 Super": 220,
    "RTX 4070": 200,
    "RTX 4060 Ti": 160,
    "RTX 4060": 115,
    "RTX 3090 Ti": 350,
    "RTX 3090": 350,
    "RTX 3080 Ti": 350,
    "RTX 3080": 320,
    "RTX 3070 Ti": 290,
    "RTX 3070": 220,
    "RTX 3060 Ti": 200,
    "RTX 3060": 170,
    "RTX 3050": 130,
    "TITAN RTX": 280,
    "RTX 2080 Ti": 260,
    "RTX 2080 Super": 250,
    "RTX 2080": 225,
    "RTX 2070 Super": 215,
    "RTX 2070": 175,
    "RTX 2060 Super": 175,
    "RTX 2060": 160,
    "GTX 1080 Ti": 250,
    "GTX 1080": 180,
    "GTX 1070 Ti": 180,
    "GTX 1070": 150,
    "GTX 1660 Ti": 120,
    "GTX 1660 Super": 125,
    "GTX 1660": 120,
    "GTX 1650 Super": 110,
    "GTX 1650": 75,
    "GTX 1060 6GB": 120,
    "GTX 1060 3GB": 120,
    "GTX 1050 Ti": 75,
    "GTX 1050": 75,
    "Sparkle Arc B580": 200
    }
    for key in gpu_tdp_dict:
        if key in title:
            return gpu_tdp_dict[key]

class GPULoader(ItemLoader):
    #we'll override where we need a list.
    default_output_processor = TakeFirst()

    name_in = MapCompose(clean_text)
    price_in = MapCompose(clean_price)
    description_in = MapCompose(clean_text,clean_description)
    tdp_in = MapCompose(define_gpu_tdp)
    # keep image_urls as a list 
    image_links_in = MapCompose(clean_text, fix_image_scheme, enhance_image)
    image_links_out = Identity()  # return the list as-is