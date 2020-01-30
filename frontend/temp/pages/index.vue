<template>
  <div class>
    <header class>
      <div class="flex justify-between items-center bg-gray-100 border-b border-gray-300 px-4 py-4">
        <logo />
        <div class="w-full px-4">
          <input
            class="w-full h-8 bg-gray-300 border border-gray-300 rounded-full px-2 outline-none focus:shadow-outline focus:bg-gray-100"
            placeholder="Search"
            dir="auto"
          />
        </div>
        <button class="focus:outline-none cursor-pointer" type="button" @click="isOpen = !isOpen">
          <svg
            class="fill-current text-gray-500 inline-block h-6 w-6"
            viewBox="0 0 20 20"
            version="1.1"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
          >
            <g v-if="!isOpen" stroke="none" stroke-width="1" fill-rule="evenodd">
              <g id="icon-shape">
                <path
                  d="M0,3 L20,3 L20,5 L0,5 L0,3 Z M0,9 L20,9 L20,11 L0,11 L0,9 Z M0,15 L20,15 L20,17 L0,17 L0,15 Z"
                />
              </g>
            </g>
            <g v-else stroke="none" stroke-width="1" fill-rule="evenodd">
              <g id="icon-shape">
                <polygon
                  points="10 8.58578644 2.92893219 1.51471863 1.51471863 2.92893219 8.58578644 10 1.51471863 17.0710678 2.92893219 18.4852814 10 11.4142136 17.0710678 18.4852814 18.4852814 17.0710678 11.4142136 10 18.4852814 2.92893219 17.0710678 1.51471863 10 8.58578644"
                />
              </g>
            </g>
          </svg>
        </button>
      </div>
      <nav v-if="isOpen" class="flex flex-col bg-gray-700 text-white p-2">
        <a href="#" class="p-2 rounded-lg hover:bg-gray-600">Home</a>
        <a href="#" class="p-2 rounded-lg hover:bg-gray-600">Authors</a>
        <a href="#" class="p-2 rounded-lg hover:bg-gray-600">Books</a>
      </nav>
    </header>
    <div class="books mt-4">
      <div>
        <h1 class="inline-block px-4 font-semibold text-2xl tracking-wide">Books</h1>
        <button class="btn btn-indigo mx-4 shadow float-right">All books</button>
      </div>
      <div class="flex flex-wrap mt-4">
        <book v-for="book in books" :book="book" :key="book.name" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5" />
      </div>
    </div>
    <div class="authors flex flex-col mt-8">
      <div class="flex justify-between">
        <h1 class="px-4 font-semibold text-2xl tracking-wide">Authors</h1>
        <button class="btn btn-indigo mx-4 shadow">All authors</button>
      </div>
      <author v-for="author in authors" :author="author" :key="author.name" class="w-full" />
    </div>
  </div>
</template>

<script>
import Logo from '~/components/Logo.vue'
import Book from '~/components/Book.vue'
import Author from '~/components/Author.vue'

export default {
  components: {
    Logo,
    Book,
    Author
  },

  data: function() {
    return {
      isOpen: false,
      authors: [{
        name: 'Leo Tolstoy',
        subtitle: 'Russian writer',
        image: 'http://www.gstatic.com/tv/thumb/persons/218434/218434_v9_ba.jpg',
      }, {
        name: 'Charles Dickens',
        subtitle: 'writer',
        image: 'https://www.biography.com/.image/t_share/MTY2NTQ1NTM2OTM2MDYwMTQ2/charles-dickens.jpg',
      }, {
        name: 'William Shakespeare',
        subtitle: 'English poet',
        image: 'http://www.gstatic.com/tv/thumb/persons/215023/215023_v9_ba.jpg',
      }, {
        name: 'Jane Austen',
        subtitle: 'Novelist',
        image: 'https://www.biography.com/.image/t_share/MTE1ODA0OTcxNTQ2ODcxMzA5/jane-austen-9192819-1-402.jpg',
      }, {
        name: 'Arthur Conan Doyle',
        subtitle: 'writer',
        image: 'http://www.gstatic.com/tv/thumb/persons/289841/289841_v9_ba.jpg',
      }],
      books: [{
        name: 'War and Peace',
        subtitle: 'Novel by Leo Tolstoy',
        image: 'https://images.penguinrandomhouse.com/cover/9781400079988',
        year: '1869'
      }, {
        name: 'Anna Karenina',
        subtitle: 'Novel by Leo Tolstoy',
        image: 'https://images4.penguinrandomhouse.com/cover/9780553902297',
        year: '1877'
      }, {
        name: 'The Death of Ivan Ilyich',
        subtitle: 'Novella by Leo Tolstoy',
        image: 'https://images-na.ssl-images-amazon.com/images/I/81WZdhB7P8L.jpg',
        year: '1886'
      }, {
        name: 'Resurrection',
        subtitle: 'Novel by Leo Tolstoy',
        image: 'https://upload.wikimedia.org/wikipedia/en/thumb/0/0e/Resurrection_%28cover%29.jpg/220px-Resurrection_%28cover%29.jpg',
        year: '1899'
      }, {
        name: 'Childhood',
        subtitle: 'Novel by Leo Tolstoy',
        image: 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1408406518l/226377.jpg',
        year: '1852'
      }]
    }
  }
}
</script>
