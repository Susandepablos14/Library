<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <CopyDataTable
        :deletet="deletet"
        :updated="updated"
      />
    </div>
  </div>
</template>

<script>
import CopyDataTable from "./Table/Copy.vue";

export default {
  name: "Copy",
  components: {
    CopyDataTable,
  },
  props: {
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
