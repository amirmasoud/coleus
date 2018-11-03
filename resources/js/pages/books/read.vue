<template>
  <b-row>
    <b-col cols="12"
           sm="4"
           md="4"
           lg="3"
           xl="2">
      <draggable v-model="myArray" class="book-contents">
        <transition-group :options="{draggable:'.item', handle:'.handle'}">
          <div v-for="element, index in myArray" :key="index" class="item">
            <img class="handle" :src="'/icons/grab.svg'" /> {{element.name}}
          </div>
        </transition-group>
      </draggable>
    </b-col>
    <b-col cols="12"
       sm="8"
       md="8"
       lg="9"
       xl="10">
<!--       <editor :doc="doc" :extensions="extensions">
        <div slot="content" slot-scope="props">
          <p>Hi, I'm just a boring paragraph</p>
        </div>
      </editor> -->
      <editor class="editor" :extensions="extensions" @update="onUpdate">

        <div class="menububble" slot="menububble" slot-scope="{ marks, focus, nodes }">
          <template v-if="nodes && marks">

            <button
              class="menububble__button"
              :class="{ 'is-active': marks.bold.active() }"
              @click="marks.bold.command"
            >
              <img :src="'/icons/bold.svg'" width="16" />
            </button>

            <button
              class="menububble__button"
              :class="{ 'is-active': marks.italic.active() }"
              @click="marks.italic.command"
            >
              <img :src="'/icons/italic.svg'" width="16" />
            </button>

            <button
              class="menububble__button"
              :class="{ 'is-active': marks.code.active() }"
              @click="marks.code.command"
            >
              <img :src="'/icons/code.svg'" width="16" />
            </button>

            <form class="menububble__form" v-if="linkMenuIsActive" @submit.prevent="setLinkUrl(linkUrl, marks.link, focus)">
              <input class="menububble__input" type="text" v-model="linkUrl" placeholder="https://" ref="linkInput" @keydown.esc="hideLinkMenu"/>
              <button class="menububble__button" @click="setLinkUrl(null, marks.link, focus)" type="button">
                <img :src="'/icons/remove.svg'" width="16" />
              </button>
            </form>

            <template v-else>
              <button class="menububble__button" @click="showLinkMenu(marks.link)" :class="{ 'is-active': marks.link.active() }">
                <img :src="'/icons/link.svg'" width="16" />
              </button>
            </template>

            <button
              class="menubar__button"
              :class="{ 'is-active': nodes.paragraph.active({ textAlign: 'left', class: 'col-12 col-md-6' }) || nodes.paragraph.active({ textAlign: 'left', class: 'col-6' }) }"
              @click="nodes.paragraph.command({ textAlign: 'left', class: lastClass })"
            >
              <img :src="'/icons/align-left.svg'" width="16" />
            </button>

            <button
              class="menubar__button"
              :class="{ 'is-active': nodes.paragraph.active({ textAlign: 'center', class: 'col-12 col-md-6' }) || nodes.paragraph.active({ textAlign: 'center', class: 'col-6' }) }"
              @click="nodes.paragraph.command({ textAlign: 'center', class: lastClass })"
            >
              <img :src="'/icons/align-center.svg'" width="16" />
            </button>

            <button
              class="menubar__button"
              :class="{ 'is-active': nodes.paragraph.active({ textAlign: 'right', class: 'col-12 col-md-6' }) || nodes.paragraph.active({ textAlign: 'right', class: 'col-6' }) }"
              @click="nodes.paragraph.command({ textAlign: 'right', class: lastClass })"
            >
              <img :src="'/icons/align-right.svg'" width="16" />
            </button>

            <button
              class="menubar__button"
              :class="{ 'is-active': nodes.paragraph.active({ class: 'col-6', textAlign: 'right' }) || nodes.paragraph.active({ class: 'col-6', textAlign: 'center' }) || nodes.paragraph.active({ class: 'col-6', textAlign: 'left' }) }"
              @click="nodes.paragraph.command({ class: 'col-12 col-md-6', textAlign: lastTextAlign })"
            >
              <img :src="'/icons/paragraph.svg'" width="16" />
            </button>

          </template>
        </div>

        <div class="editor__content" slot="content" slot-scope="props" dir="auto">
          <p>Write something awesome</p>
        </div>

      </editor>
    </b-col>
  </b-row>
</template>

<script>
import gql from 'graphql-tag'
import draggable from 'vuedraggable'
import { Editor } from 'tiptap'
import {
  BlockquoteNode,
  BulletListNode,
  CodeBlockNode,
  HardBreakNode,
  HeadingNode,
  ListItemNode,
  OrderedListNode,
  TodoItemNode,
  TodoListNode,
  BoldMark,
  CodeMark,
  ItalicMark,
  LinkMark,
  HistoryExtension,
  PlaceholderExtension
} from 'tiptap-extensions'
import ParagraphAlignmentNode from '~/components/editor/Paragraph.js'

export default {
  metaInfo () {
    return { title: this.$t('read_book') }
  },

  components: { draggable, Editor },

  data: () => ({
    linkUrl: null,
    linkMenuIsActive: false,
    json: 'Update content to see changes',
    html: 'Update content to see changes',
    lastClass: 'col-12 col-md-6',
    lastTextAlign: 'left',
    extensions: [
      new BlockquoteNode(),
      new BulletListNode(),
      new CodeBlockNode(),
      new HardBreakNode(),
      new HeadingNode({ maxLevel: 3 }),
      new ListItemNode(),
      new OrderedListNode(),
      new TodoItemNode(),
      new TodoListNode(),
      new BoldMark(),
      new CodeMark(),
      new ItalicMark(),
      new LinkMark(),
      new HistoryExtension(),
      new PlaceholderExtension({
        emptyNodeClass: 'is-empty',
      }),
      new ParagraphAlignmentNode()
    ],
    myArray: [
      {
        "name": "vue.draggable",
        "order": 1,
        "fixed": false
      },
      {
        "name": "draggable",
        "order": 2,
        "fixed": false
      },
      {
        "name": "component",
        "order": 3,
        "fixed": false
      },
      {
        "name": "for",
        "order": 4,
        "fixed": false
      },
      {
        "name": "vue.js 2.0",
        "order": 5,
        "fixed": false
      },
      {
        "name": "based",
        "order": 6,
        "fixed": false
      },
      {
        "name": "on",
        "order": 7,
        "fixed": false
      },
      {
        "name": "Sortablejs",
        "order": 8,
        "fixed": false
      }
    ]
  }),

  methods: {
    showLinkMenu(type) {
      this.linkUrl = type.attrs.href
      this.linkMenuIsActive = true
      this.$nextTick(() => {
        this.$refs.linkInput.focus()
      })
    },
    hideLinkMenu() {
      this.linkUrl = null
      this.linkMenuIsActive = false
    },
    setLinkUrl(url, type, focus) {
      type.command({ href: url })
      this.hideLinkMenu()
      focus()
    },
    onUpdate({ getJSON, getHTML }) {
      this.lastClass = getJSON().content[getJSON().content.length - 1].attrs.class
      this.lastTextAlign = getJSON().content[getJSON().content.length - 1].attrs.textAlign
    },
  }
}
</script>

<style scoped>
.handle {
  cursor: grab;
  cursor: -webkit-grab;
}

.handle:active {
  cursor: grabbing;
  cursor: -webkit-grabbing;
}

.text-align {
  &--left {
    text-align: left;
  }
  &--center {
    text-align: center;
  }
  &--right {
    text-align: right;
  }
}
</style>
