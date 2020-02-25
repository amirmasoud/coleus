# -*- coding: utf-8 -*-
import scrapy


class HafezMasnaviSpider(scrapy.Spider):
    name = "hafez_masnavi"
    allowed_domains = ["ganjoor.net"]
    start_urls = ['https://ganjoor.net/hafez/masnavi']
    order = 1

    def parse(self, response):
        sh = {}
        sh['unit'] = 'مثنوی'
        sh['text'] = {}
        for index, poem in enumerate(response.css('div.poem>article>div.b')):
            if index == 0:
                sh['title'] = 'مثنوی'
                sh['order'] = self.order
                self.order = self.order + 1
            sh['text'][index] = {
                'm1': poem.css('div.m1>p::text').extract_first(),
                'm2': poem.css('div.m2>p::text').extract_first(),
            }
        yield sh
