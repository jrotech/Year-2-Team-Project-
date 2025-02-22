from scrapy.loader import ItemLoader
from itemloaders.processors  import TakeFirst, MapCompose, Join
import re

def clean_price(values):    # values gives everything the loader extracted, and the function is not called on each part, just once on the whole list
    print (values)
    price_str = "".join(values).replace("£", "").replace(",", "").strip()  # Join parts first
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
    description_in = MapCompose(clean_text)
    socket_type_in = MapCompose(clean_text)
    tdp_in = MapCompose(clean_text, extract_tdp)  
    integrated_graphics_in = MapCompose(clean_text, hasGraphics)
    image_urls_out = Join(",")  # Joins list of image URLs into a string