import { setBlockType } from 'tiptap-commands'
import { Node } from 'tiptap'

export default class HalfWidthNode extends Node {

    get name() {
        return 'halfWidth'
    }

    get schema() {
        return {
            attrs: {
                textWidth: {
                    default: 'col-12',
                },
            },
            content: 'inline*',
            group: 'block',
            draggable: false,
            parseDOM: [{
                tag: 'p',
                getAttrs: node => ({
                    textWidth: node.class,
                    textAlign: node.style.textAlign
                }),
            }],
            toDOM: node => ['p', { class: `${node.attrs.textWidth}`, style: `text-align: ${node.attrs.textAlign}` }, 0],
        }
    }

    command({ type, attrs }) {
        return setBlockType(type, attrs)
    }
}
