<template>
    <div class="switch">
        <input v-if="active"
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

        <label for="toggle-webhook"></label>
    </div><!-- /.switch -->
</template>

<script>
    export default {
        data() {
            return {
                active: false,
                webhook: {},
            }
        },

        created() {
            this.get();
        },

        methods: {
            get() {
                axios.get('/webhooks')
                    .then((response) => {
                        this.active = response.data.find((webhook) => {
                            return webhook.config.url === 'http://downstream.test/webhook';
                        })
                    })
            },

            create() {
                axios.post('/webhooks')
                    .then(() => {
                        this.active = true;
                    });
            },

            destroy() {
                axios.delete(`/webhooks/${this.webhook.id}`)
                    .then(() => {
                        this.active = false;
                    });
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
</style>
