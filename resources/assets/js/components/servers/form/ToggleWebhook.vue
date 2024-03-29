<template>
    <div class="switch">
        <transition name="fade" mode="out-in">
            <span v-if="pending">
                <i class="fas fa-spinner fa-spin"></i>
            </span>

            <template v-else>
                <input v-if="webhook"
                       @click="destroy"
                       id="toggle-webhook"
                       class="cmn-toggle cmn-toggle-round"
                       type="checkbox"
                       checked>

                <input v-else
                       id="toggle-webhook"
                       @click="create"
                       class="cmn-toggle cmn-toggle-round"
                       type="checkbox">
            </template>
        </transition>

        <label for="toggle-webhook"></label>
    </div><!-- /.switch -->
</template>

<script>
    export default {
        data() {
            return {
                webhook: null,
                pending: false
            }
        },

        props: {
            project: {
                type: Object
            }
        },

        created() {
            if (this.project) this.get();
        },

        methods: {
            get() {
                this.pending = true;

                axios.get(`/projects/${this.project.id}/webhooks`)
                    .then((response) => {
                        this.webhook = response.data.find((webhook) => {
                            return this.validateWebhook(webhook.config.url);
                        });

                        this.pending = false;
                    })
            },

            create() {
                axios.post(`/projects/${this.project.id}/webhooks`)
                    .then((response) => {
                        this.webhook = response.data;
                    });
            },

            destroy() {
                axios.delete(`/projects/${this.project.id}/webhooks/${this.webhook.id}`)
                    .then(() => {
                        this.webhook = null;
                    });
            },

            /**
             * Validate whether the given url matches the url from our .env file.
             */
            validateWebhook(url) {
                return url === process.env.MIX_GITHUB_WEBHOOK_URL;
            }
        }
    };
</script>

<style lang="scss" scoped>
    .cmn-toggle {
        display: none;
    }

    .cmn-toggle + label {
        display: inline-block;
        position: relative;
        cursor: pointer;
        outline: none;
        user-select: none;
        margin: 0;
    }

    input.cmn-toggle-round + label {
        padding: 2px;
        width: 30px;
        height: 15px;
        background-color: #dddddd;
        border-radius: 15px;
    }

    input.cmn-toggle-round + label:before,
    input.cmn-toggle-round + label:after {
        display: block;
        position: absolute;
        top: 1px;
        left: 1px;
        bottom: 1px;
        content: "";
    }

    input.cmn-toggle-round + label:before {
        right: 1px;
        background-color: #f1f1f1;
        border-radius: 15px;
        transition: background 0.4s;
    }

    input.cmn-toggle-round + label:after {
        width: 13px;
        background-color: #fff;
        border-radius: 100%;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: margin 0.4s;
    }

    input.cmn-toggle-round:checked + label:before {
        background-color: #28a745;
    }

    input.cmn-toggle-round:checked + label:after {
        margin-left: 15px;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>
