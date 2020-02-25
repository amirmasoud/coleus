# -*- coding: utf-8 -*-
import json, scrapy, sys, os, errno, re
reload(sys)
sys.setdefaultencoding('utf8')

class GanjoorBooks(scrapy.Spider):
    name = 'ganjoorbooks'
    start_urls = ['https://ganjoor.net']
    debug = True

    def parse(self, response):
        with open('books.json') as f:
            books = json.load(f)
        for book in books:
            content = scrapy.Request(book['link'], callback=self.parseContent)
            content.meta['book_link'] = book['link']
            print content
            yield content

    def parseContent(self, response):
        item_link = response.meta['book_link']

        # Reach data
        # if not response.css('div.poem p.b').extract_first():
        if not re.search('https://ganjoor.net/([a-zA-Z0-9]+/)+(sh[0-9]+|mosammat)/?', item_link):
            for i, item in enumerate(response.css("div.poem>article a")):
                if str(item.css('::attr(href)').extract_first()).startswith(item_link) and len(item.css('::attr(href)').extract_first()) > len(item_link):
                    nextLevel = scrapy.Request(item.css('::attr(href)').extract_first(), callback=self.parseContent)
                    nextLevel.meta['book_link'] = item.css('::attr(href)').extract_first()
                    yield nextLevel

        # Crawl data
        sh = self.getContent(response)

        # Save data
        path = str('data/' + str(item_link.replace('https://ganjoor.net/', '')))
        self.mkdir_p(path)
        with open(path + 'output.json', 'w') as output:
            print sh
            json.dump(sh, output)

    def getContent(self, response):
        index = 0
        sh = dict()
        sh["text"] = dict()
        for i, poem in enumerate(response.css("div.poem>article>*")):
            if poem.css("p::text").extract_first() is None or 'rel="bookmark"' in poem.css('*').extract_first() or 'class="spacer"' in poem.css('*').extract_first() or '<div style=' in poem.css('*').extract_first():
                continue
            if len(poem.css("div.m1>p")) == 1:
                if poem.css("div.b"):
                    if '٭٭٭' not in poem.css("div.m1>p::text").extract_first() and ''.join(poem.css("div.m1>p::text").extract()).strip() != '':
                        sh["text"][index] = dict([
                            ("m1", ''.join(poem.css("div.m1>p::text").extract()).strip()),
                            ("m2", ''.join(poem.css("div.m2>p::text").extract()).strip()),
                        ])
                else:
                    if '٭٭٭' not in poem.css("p:first-child::text").extract_first() and ''.join(poem.css("p:first-child::text").extract()).strip() != '':
                        sh["text"][index] = dict([
                            ("t1", ''.join(poem.css("p:first-child::text").extract()).strip()),
                            ("t2", ''.join(poem.css("p:last-child::text").extract()).strip()),
                        ])
            else:
                if poem.css("div.b2"):
                    if '٭٭٭' not in poem.css("p:first-child::text").extract_first() and ''.join(poem.css("p:first-child::text").extract()).strip() != '':
                        sh["text"][index] = dict([
                            ("t1", ''.join(poem.css("p:first-child::text").extract()).strip()),
                            ("t2", ''.join(poem.css("p:last-child::text").extract()).strip()),
                        ])
                else:
                    if '٭٭٭' not in poem.css('p::text').extract_first() and ''.join(poem.css('p::text').extract()).strip() != '':
                        sh['text'][index] = dict([
                            ('p', ''.join(poem.css('p::text').extract()).strip())
                        ])
            index = index + 1
        return sh

    def mkdir_p(self, path):
        try:
            os.makedirs(path)
        except OSError as exc:
            if exc.errno == errno.EEXIST and os.path.isdir(path):
                pass
            else:
                print 'raise'
                raise


        # book_link = response.meta['book_link']
        # sh = dict()
        # index = 0
        # if response.css('div.poem article div.b'):
        #     for content in response.css('div.poem article div.b'):
        #         b = {
        #             'm1': content.css('div.m1>p::text').extract_first(),
        #             'm2': content.css('div.m2>p::text').extract_first()
        #         }
        #         sh[index] = b
        #         index = index + 1
        #         yield b
        # with open('test.json', 'w') as output:
        #     json.dump(sh, output)
        # for content in response.css('div.poem p'):
        #     content_link = content.css('a::attr(href)').extract_first()
        #     content_text = content.css('a::text').extract_first()
        #     if content_text is not None and content_link.startswith(book_link) and len(content_link) > len(book_link):
        #         yield {
        #             'title': book.css('a::text').extract_first(),
        #             'link': book.css('a::attr(href)').extract_first()
        #         }
