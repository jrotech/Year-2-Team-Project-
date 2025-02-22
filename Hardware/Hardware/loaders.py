from scrapy.loader import ItemLoader
from itemloaders.processors  import TakeFirst, MapCompose, Join
import re

def clean_price(value):
    return value.replace("£", "").replace(",", "").strip()