<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <CategoryDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import CategoryDataTable from "./Table/Category.vue";

export default {
  name: "Category",
  components: {
    CategoryDataTable,
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
