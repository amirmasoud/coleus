<template>

  <autocomplete
    url="http://negarin.dev/api/v1/search"
    anchor="title"
    label="author"
    :classes="{input: 'form-control'}"
    placeholder="جستجو"
    :on-select="getData">
  </autocomplete>

</template>


<script>

  import Autocomplete from './Autocomplete.vue';

  export default {

    components: { Autocomplete },

    methods: {
      getData(obj){
        window.location = obj.link;
      }
    }
  };

</script>