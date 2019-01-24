declare namespace WPGlobal {
  interface WP {
    blocks: {
      registerBlockType: (namespace: string, block: Block) => null
    }
    element: {
      createElement(
        tag: string,
        attributes: { [key: string]: any },
        content: any
      )
    }
    i18n: {
      __: any
    }
  }

  interface Block {
    title: string
    icon?: string
    category?: string
    supports?: {
      html?: boolean
    }
    edit?(props: any): any
    save?(): any
  }
}
