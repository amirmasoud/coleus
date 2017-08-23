<template>
  <div id="table">
  </div>
</template>

<script>
import VueFroala from 'vue-froala-wysiwyg';

export default {
  data () {
    return {
      config: {
        events: {
          'froalaEditor.initialized': function () {
            console.log('initialized')
          }
        }
      },
      model: 'Edit Your Content Here!'
    }
  },
  mounted: function() {
    console.log('Mounted')
  }
}
</script>