<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <BookDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import BookDataTable from "./Table/Book.vue";

export default {
  name: "Book",
  components: {
    BookDataTable,
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
