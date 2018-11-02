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
                textWidth: {
                    default: 'col-12'
                }
            },
            content: 'inline*',
            group: 'block',
            draggable: false,
            parseDOM: [{
                tag: 'p',
                getAttrs: node => ({
                    textAlign: node.style.textAlign,
                    class: node.class
                }),
            }],
            toDOM: node => ['p', { class: `${node.attrs.textWidth}`, style: `text-align: ${node.attrs.textAlign}` }, 0],
        }
    }

    command({ type, attrs }) {
        return setBlockType(type, attrs)
    }
}
