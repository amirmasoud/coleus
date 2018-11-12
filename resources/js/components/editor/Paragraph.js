import { setBlockType } from 'tiptap-commands'
import { Node } from 'tiptap'

export default class ParagraphNode extends Node {

    get name() {
        return 'paragraph'
    }

    get schema() {
        return {
            attrs: {
                textAlign: {
                    default: 'left',
                },
                class: {
                    default: 'col-12'
                }
            },
            content: 'inline*',
            group: 'block',
            draggable: false,
            parseDOM: [{
                tag: 'p',
                getAttrs: node => ({
                    textAlign: node.attributes ? node.attributes.textAlign : node.attrs.textAlign,
                    class: node.attributes ? node.attributes.class : node.attrs.class
                }),
            }],
            toDOM: node => ['p', { class: `${node.attrs.class}`, style: `text-align: ${node.attrs.textAlign}` }, 0],
        }
    }

    command({ type, attrs }) {
        return setBlockType(type, attrs)
    }
}
