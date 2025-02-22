from scrapy.loader import ItemLoader
from itemloaders.processors  import TakeFirst, MapCompose, Join
import re

def clean_price(value):
    return value.replace("£", "").replace(",", "").strip()
def clean_text(value):
    return value.strip()
def extract_tdp(value):
    #regex for '350W' -> '350'
    match = re.search(r"(\d+)\s*W", value)
    return match.group(1) if match else value