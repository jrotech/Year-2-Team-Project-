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
    image_urls = scrapy.Field()  # image links
    images = scrapy.Field()  #downloaded image data
    url = scrapy.Field()

class LinkItem(scrapy.Item):
    link = scrapy.Field()
    category = scrapy.Field()
    pass

class HardwareItem(scrapy.Item):
    # define the fields for your item here like:
    # name = scrapy.Field()
    pass
