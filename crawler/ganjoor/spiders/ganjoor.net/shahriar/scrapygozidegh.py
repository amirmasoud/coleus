# -*- coding: utf-8 -*-
import scrapy

class scrapygozideghSpider(scrapy.Spider):
    name = "scrapygozidegh"
    allowed_domains = ["ganjoor.net"]
    if 160 == 1:
        start_urls = ["https://ganjoor.net/shahriar/gozidegh/sh"]
    else:
        start_urls = ["https://ganjoor.net/shahriar/gozidegh/sh" + "1"]
    order = 1

    def parse(self, response):
        index = 0
        sh = dict()
        sh["type"] = "ghazal"
        sh["text"] = dict()
        for i, poem in enumerate(response.css("div.poem>article>div")):
            if poem.css("p:first-child::text").extract_first() is None:
                continue
            if index == 0:
                if 1 == 1:
                    sh["title"] = "غزل" + " شماره " + str(self.order) + " - " + ''.join(poem.css("div.m1>p::text").extract()).strip()
                elif 1 == 2:
                    sh["title"] = "غزل" + " شماره " + str(self.order) + " - " + ''.join(poem.css("div.m2>p::text").extract()).strip()
                elif 1 == 3:
                    sh["title"] = "غزل" + " شماره " + str(self.order) + " - " + ''.join(response.css("div.poem>article>h2>a::text").extract()).strip() + ': ' + ''.join(poem.css("div.m1>p::text").extract()).strip()
                elif 1 == 4:
                    sh["title"] = "غزل" + " شماره " + str(self.order) + " - " + ''.join(response.css("div.poem>article>h2>a::text").extract()).strip() + ': ' + ''.join(poem.css("div.m2>p::text").extract()).strip()
                else:
                    sh["title"] = response.css("div.poem>article>h2>a::text").extract_first()
            if len(poem.css("div.m1>p")) == 1:
                if poem.css("div.b"):
                    sh["text"][index] = dict([
                        ("m1", ''.join(poem.css("div.m1>p::text").extract()).strip()),
                        ("m2", ''.join(poem.css("div.m2>p::text").extract()).strip()),
                    ])
                else:
                    sh["text"][index] = dict([
                        ("t1", ''.join(poem.css("p:first-child::text").extract()).strip()),
                        ("t2", ''.join(poem.css("p:last-child::text").extract()).strip()),
                    ])
            else:
                if poem.css("div.b2"):
                    sh["text"][index] = dict([
                        ("t1", ''.join(poem.css("p:first-child::text").extract()).strip()),
                        ("t2", ''.join(poem.css("p:last-child::text").extract()).strip()),
                    ])
                else:
                    sh['text'][index] = dict([
                        ('p', ''.join(poem.css('p:first-child::text').extract()).strip())
                    ])
            index = index + 1
        sh["order"] = self.order
        self.order = self.order + 1
        yield sh
        # next_page = response.css("div.navigation>div.navleft>a::attr(href)").extract_first()
        if self.order < (160 + 1):
            next_page = response.urljoin("https://ganjoor.net/shahriar/gozidegh/sh" + str(self.order))
            yield scrapy.Request(next_page, callback=self.parse)
            