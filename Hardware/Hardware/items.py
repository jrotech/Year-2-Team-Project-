# Define here the models for your scraped items
#
# See documentation in:
# https://docs.scrapy.org/en/latest/topics/items.html

import scrapy


class CPUItem(scrapy.Item):
    name = scrapy.Field()
    price = scrapy.Field()
    description = scrapy.Field()
    socket_type = scrapy.Field()
    tdp = scrapy.Field()
    integrated_graphics = scrapy.Field()
    image_links = scrapy.Field()  # image links
    
class GPUItem(scrapy.Item):
    name = scrapy.Field()
    price = scrapy.Field()
    description = scrapy.Field()    
    image_links = scrapy.Field()  # image links
  
class LinkItem(scrapy.Item):
    link = scrapy.Field()
    category = scrapy.Field()
    price = scrapy.Field()
    pass

class HardwareItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
    pass
