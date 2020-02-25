import json, scrapy


class GanjoorBooks(scrapy.Spider):
    name = 'ganjoorbooks'
    start_urls = ['https://ganjoor.net']

    def parse(self, response):
        with open('authors.json') as f:
            authors = json.load(f)
        
        for author in authors:
            yield scrapy.Request(author['link'], callback=self.parseBooks)


    def parseBooks(self, response):
        for book in response.css('div.poem p'):
            if book.css('a::text').extract_first() is not None and 'https://ganjoor.net/' in book.css('a::attr(href)').extract_first():
                yield {
                    'title': book.css('a::text').extract_first(),
                    'link': book.css('a::attr(href)').extract_first()
                }
