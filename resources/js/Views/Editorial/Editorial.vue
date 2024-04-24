<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <EditorialDataTable
        :create="create"
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import EditorialDataTable from "./Table/Editorial.vue";

export default {
  name: "Editorial",
  components: {
    EditorialDataTable,
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
