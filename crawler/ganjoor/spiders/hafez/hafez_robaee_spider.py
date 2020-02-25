# -*- coding: utf-8 -*-
import scrapy

class HafezMasnaviSpider(scrapy.Spider):
    name = "hafez_robaee"
    allowed_domains = ["ganjoor.net"]
    order = 1
    url = 'https://ganjoor.net/hafez/robaee2/sh'
    start_urls = [url + str(order)]

    def parse(self, response):
        sh = {}
        sh['type'] = 'robaee'
        sh['text'] = {}
        for index, poem in enumerate(response.css('div.poem>article>div.b')):
            if index == 0:
                sh['title'] = 'رباعی شماره‌ی ' + str(self.order) + ' - ' + poem.css('div.m1>p::text').extract_first()
                sh['order'] = self.order
                self.order = self.order + 1
            sh['text'][index] = {
                'm1': poem.css('div.m1>p::text').extract_first(),
                'm2': poem.css('div.m2>p::text').extract_first(),
            }
        yield sh
        next_page = self.url + str(self.order)
        if self.order < 43:
            next_page = response.urljoin(next_page)
            yield scrapy.Request(next_page, callback=self.parse)
