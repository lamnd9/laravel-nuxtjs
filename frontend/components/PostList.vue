<!-- components/PostList.vue -->
<template>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Tiêu đề</th>
        <th>Nội dung</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="post in posts" :key="post.id">
        <td @click="$emit('edit', post)" style="cursor: pointer;" class="text-primary">{{ post.id }}</td>
        <td>{{ post.title }}</td>
        <td>{{ post.content }}</td>
        <td>
          <button class="btn btn-sm btn-danger" @click="$emit('delete', post.id)">Xoá</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup lang="ts">
defineProps<{
  posts: Array<any>
}>()

defineEmits(['edit', 'delete'])
</script>
