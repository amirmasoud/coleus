import json, os

with open('authors.json') as f:
    authors = json.load(f)
for author in authors:
    self.author_links.append(author['link'])


