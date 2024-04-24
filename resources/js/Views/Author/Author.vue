<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <AuthorDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import AuthorDataTable from "./Table/Author.vue";

export default {
  name: "Author",
  components: {
    AuthorDataTable,
  },
  props: {
    create: {
      type: String,
      default: 0,
    },
    deletet: {
      type: String,
      default: 0,
    },
    updated: {
      type: String,
      default: 0,
    },
  },
};
</script>
