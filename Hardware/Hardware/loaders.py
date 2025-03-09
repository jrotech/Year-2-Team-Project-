from scrapy.loader import ItemLoader
from itemloaders.processors  import TakeFirst, MapCompose, Join, Identity
import re

def clean_price(value):
    price_str = value.replace("£", "").replace(",", "").strip()  
    return price_str

def clean_text(value):
    return value.strip()
def extract_tdp(value):
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
    tdp_in = MapCompose(clean_text, extract_tdp)  
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

class GPULoader(ItemLoader):
    #we'll override where we need a list.
    default_output_processor = TakeFirst()

    name_in = MapCompose(clean_text)
    price_in = MapCompose(clean_price)
    description_in = MapCompose(clean_text,clean_description)
    # keep image_urls as a list 
    image_links_in = MapCompose(clean_text, fix_image_scheme, enhance_image)
    image_links_out = Identity()  # return the list as-is