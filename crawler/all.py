# -*- coding: utf-8 -*-
import json, scrapy, sys, os, errno, re
from scrapy.spiders import CrawlSpider, Rule
from scrapy.linkextractors import LinkExtractor
from scrapy.linkextractors.sgml import SgmlLinkExtractor

reload(sys)
sys.setdefaultencoding('utf8')

class testSpider(CrawlSpider):
    name = "test"
    bot_name = 'test'
    allowed_domains = ["ganjoor.net"]
    start_urls = ["https://ganjoor.net/"]
    rules = (
        Rule(SgmlLinkExtractor(allow_domains=()), callback='parse_content',process_links="filter_links",follow= True),
    )
    custom_settings = {
        'LOG_LEVEL': 'INFO'
    }
    exclude = ['/vazn','?comments_popup=','/bp/','/?v=','blog.ganjoor.net/','i.ganjoor.net/','http://ganjoor.net/contact/', '/report/']
    author_links = list()

    def __init__(self, *a, **kw):
        super(testSpider, self).__init__(*a, **kw)
        with open('authors.json') as f:
            authors = json.load(f)
        for author in authors:
            self.author_links.append(author['link'])

    def filter_links(self, links):
        for link in links:
            if self.filter(link.url):
                continue
            yield link

        # for link in links:
        #     if self.filter(link.url):
        #         pass

            # if not any(author in link.url for author in self.author_links):
            #     # or not re.search('https://ganjoor.net/([a-zA-Z0-9]+/?)', link.url):
            #     pass

        # return links

    def filter(self, url):
        for author_link in self.author_links:
            if url.startswith(author_link):
                return False
        return True


    def parse_content(self, response):
        print response.request.url

        # Reach data
        # if not response.css('div.poem p.b').extract_first():
        if re.search('https://ganjoor.net/([a-zA-Z0-9]+/)+(sh[0-9]+)/?', response.request.url):

            # Crawl data
            sh = self.get_content(response)

            # Save data
            path = str('data/' + str(response.request.url.replace('https://ganjoor.net/', '')))
            self.mkdir_p(path)

            with open(path + 'output.json', 'w') as output:
                json.dump(sh, output)

    def get_content(self, response):
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
                print 1
                pass
            else:
                raise
