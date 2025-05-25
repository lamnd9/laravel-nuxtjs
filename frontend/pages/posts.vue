<template>
  <div class="container mt-5">
    <h1 class="mb-4">Quản lý bài viết</h1>

    <button class="btn btn-primary mb-3" @click="openAddModal">+ Thêm mới</button>

    <PostList :posts="posts" @edit="openEditModal" @delete="deletePost" />

    <!-- Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" ref="postModalEl">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ modalTitle }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" />
          </div>
          <div class="modal-body">
            <PostForm :form="form" @submit="submitPost" @reset="closeModal" />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import PostList from '~/components/PostList.vue'
import PostForm from '~/components/PostForm.vue'

const config = useRuntimeConfig()
const api = config.public.apiBase

const posts = ref<any[]>([])
const form = ref({ id: null, title: '', content: '' })

const modalTitle = ref('Thêm bài viết')
const postModalEl = ref()
let postModal: any = null

onMounted(async () => {
  await fetchPosts()

  // Bootstrap modal instance
  const bootstrap = await import('bootstrap')
  postModal = new bootstrap.Modal(postModalEl.value)
})

async function fetchPosts() {
  posts.value = await $fetch(`${api}/posts`)
}

async function submitPost(payload: any) {
  if (payload.id) {
    await $fetch(`${api}/posts/${payload.id}`, { method: 'PUT', body: payload })
  } else {
    await $fetch(`${api}/posts`, { method: 'POST', body: payload })
  }
  await fetchPosts()
  closeModal()
}

function openAddModal() {
  modalTitle.value = 'Thêm bài viết'
  form.value = { id: null, title: '', content: '' }
  postModal.show()
}

function openEditModal(post: any) {
  modalTitle.value = 'Cập nhật bài viết'
  form.value = { ...post }
  postModal.show()
}

function closeModal() {
  postModal.hide()
}
async function deletePost(id: number) {
  if (!confirm('Bạn có chắc muốn xoá bài viết này?')) return

  await $fetch(`${api}/posts/${id}`, { method: 'DELETE' })
  await fetchPosts()
}
</script>
