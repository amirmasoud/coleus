
# -*- coding: utf-8 -*-
import scrapy

class FerdosiShahnameSpider(scrapy.Spider):
    name = "bahram19"
    allowed_domains = ["ganjoor.net"]
    start_urls = ["https://ganjoor.net/ferdousi/shahname/bahram19/sh1/"]
    order = 1

    def parse(self, response):
        sh = dict()
        sh["type"] = "masnavi"
        sh["text"] = dict()
        for index, poem in enumerate(response.css("div.poem>article>div.b")):
            if index == 0:
                sh["title"] = response.css("div.poem>article>h2>a::text").extract_first()
                sh["order"] = self.order
                self.order = self.order + 1
            sh["text"][index] = dict([
                ("m1", poem.css("div.m1>p::text").extract_first()),
                ("m2", poem.css("div.m2>p::text").extract_first()),
            ])
        yield sh
        next_page = response.css("div.navigation>div.navleft>a::attr(href)").extract_first()
        if next_page is not None:
            next_page = response.urljoin(next_page)
            yield scrapy.Request(next_page, callback=self.parse)