import scrapy

class GanjoorAuthors(scrapy.Spider):
    name = 'ganjoorauthors'
    start_urls = ['https://ganjoor.net']

    def parse(self, response):
        for poet in response.css('div.poet'):
            yield {
                'title': poet.css('a::text').extract_first(), 
                'link': poet.css('a::attr(href)').extract_first(),
                'img': poet.css('a>img::attr(src)').extract_first()
            }
