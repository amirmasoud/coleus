# -*- coding: utf-8 -*-
import scrapy

class RumiShamsTarjeatSpider(scrapy.Spider):
    name = "shams_tarjeat"
    allowed_domains = ["ganjoor.net"]
    start_urls = ['https://ganjoor.net/moulavi/shams/tarjeeat/sh1/']
    order = 1

    def parse(self, response):
        index = 0
        sh = {}
        sh['type'] = 'tarje'
        sh['text'] = {}
        for i, poem in enumerate(response.css('div.poem>article>div')):
            if poem.css('p:first-child::text').extract_first() is None:
                continue
            if index == 0:
                sh['title'] = 'ترجیع شماره ' + str(self.order) + ' - ' + poem.css('div.m1>p::text').extract_first()
                sh['order'] = self.order
                self.order = self.order + 1
            if poem.css("div.b"):
                sh['text'][index] = {
                    'm1': poem.css('div.m1>p::text').extract_first(),
                    'm2': poem.css('div.m2>p::text').extract_first(),
                }
            else:
                sh['text'][index] = {
                    't1': poem.css('p:first-child::text').extract_first(),
                    't2': poem.css('p:last-child::text').extract_first(),
                }
            index = index + 1
        yield sh
        next_page = response.css('div.navigation>div.navleft>a::attr(href)').extract_first()
        if next_page is not None:
            next_page = response.urljoin(next_page)
            yield scrapy.Request(next_page, callback=self.parse)
