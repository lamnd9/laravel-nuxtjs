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
const form = ref({ id: null, title: '', content: '', views: 0, start_at: '', end_at: '' })

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
  try {
    // Format lại các field ngày giờ
    const formatted = {
      ...payload,
      start_at: formatDateTime(payload.start_at),
      end_at: formatDateTime(payload.end_at),
    }

    if (formatted.id) {
      await $fetch(`${api}/posts/${formatted.id}`, {
        method: 'PUT',
        body: formatted,
      })
    } else {
      await $fetch(`${api}/posts`, {
        method: 'POST',
        body: formatted,
      })
    }

    await fetchPosts()
    closeModal()
  } catch (err) {
    console.error(err)
  }
}

function openAddModal() {
  modalTitle.value = 'Thêm bài viết'
  form.value = { id: null, title: '', content: '', views: 0, start_at: '', end_at: '' }
  postModal.show()
}

function openEditModal(post: any) {
  modalTitle.value = 'Cập nhật bài viết'
  form.value = {
    id: post.id,
    title: post.title,
    content: post.content,
    views: post.views,
    start_at: formatForInput(post.start_at),
    end_at: formatForInput(post.end_at),
  }
  postModal.show()
}

function formatForInput(datetime: string | null) {
  if (!datetime) return ''
  const date = new Date(datetime)
  return date.toISOString().slice(0, 16) // -> "YYYY-MM-DDTHH:mm"
}

function closeModal() {
  postModal.hide()
}
async function deletePost(id: number) {
  if (!confirm('Bạn có chắc muốn xoá bài viết này?')) return

  await $fetch(`${api}/posts/${id}`, { method: 'DELETE' })
  await fetchPosts()
}

function formatDateTime(value: string | null) {
  if (!value) return null
  const date = new Date(value)
  return date.toISOString().slice(0, 19).replace('T', ' ') // "YYYY-MM-DD HH:mm:ss"
}
</script>
