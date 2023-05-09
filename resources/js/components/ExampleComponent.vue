<script>
export default {
    data() {
        return {
            loading: false,
            title: {
                alias: "Title",
                value: null,
            },
            description: {
                alias: "Description",
                value: null,
            },
        };
    },
};
</script>
<template>
    <div class="card shadow">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">{{ title.alias }}</label>
                <input
                    type="email"
                    class="form-control"
                    v-model="title.alias"
                    :placeholder="title.alias"
                    :disabled="loading"
                />
            </div>
            <div class="mb-3">
                <label class="form-label">{{ description.alias }}</label>
                <textarea
                    class="form-control"
                    rows="3"
                    v-model="description.value"
                    :placeholder="description.alias"
                    :disabled="loading"
                ></textarea>
            </div>
        </div>
    </div>
</template>
