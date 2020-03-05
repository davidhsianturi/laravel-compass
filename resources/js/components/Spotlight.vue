<script>
export default {
    created() {
        document.addEventListener('keydown', this.handleEventKey);
    },

    destroyed() {
        document.removeEventListener('keydown', this.handleEventKey);
    },

    data() {
        return {
            query: '',
            endpointList: [],
            currentActiveItem: null
        }
    },

    mounted() {
        this.getEndpoints();
        this.focusedSearchInput();
    },

    computed: {
        filteredEndpoints() {
            const normalizedQuery = this.query.toLowerCase().trim();
            return this.endpointList.filter(item => {
                return item.title.toLowerCase().includes(normalizedQuery);
            })
        },
        lastItem() {
            return this.filteredEndpoints.length - 1;
        },
        resultsNotEmpty() {
            return this.query && this.filteredEndpoints.length > 0;
        }
    },

    methods: {
        focusedSearchInput() {
            this.$nextTick(() => {
                this.$refs.spotlightSearchInput.focus();
            })
        },
        async getEndpoints() {
            try {
                const { data } = await this.$http.get('/' + Compass.path + '/request');
                const endpoints = await data.data.list.map(item => ({
                    id: item.id,
                    title: item.title,
                    description: item.description,
                    method: item.content.selectedMethod || item.info.methods[0]
                }));

                this.endpointList = endpoints;
            } catch (err) {/* throw */}
        },
        handleEventKey(e) {
            e.stopPropagation();
            if (e.key == 'Escape') {
                this.close();
            }
        },
        close() {
            this.$root.spotlight.open = false;
        },
        onPointedItem(index) {
            this.currentActiveItem = index;
            this.focusedSearchInput();
        },
        updateQuery(val) {
            this.query = val;
            if (this.resultsNotEmpty) {
                this.currentActiveItem = 0;
            }
        },
        pointerDown() {
            if (this.resultsNotEmpty && this.currentActiveItem < this.lastItem) {
                this.currentActiveItem++
                this.adjustScroll();
                // this.debugPointer();
            }
        },
        pointerUp() {
            if (this.resultsNotEmpty && this.currentActiveItem > 0) {
                this.currentActiveItem--
                this.adjustScroll();
                // this.debugPointer();
            }
        },
        adjustScroll() {
            if (this.highlightedItem().distance.top <= this.viewport().top) {
                return this.$refs.results.scrollTop = this.highlightedItem().distance.top;
            } else if (this.highlightedItem().distance.bottom >= this.viewport().bottom) {
                return this.$refs.results.scrollTop = this.viewport().top + this.highlightedItem().height;
            }
        },
        highlightedItem() {
            const itemHeight = this.$refs.item[this.currentActiveItem].$el.offsetHeight;
            const pointerTop = itemHeight * this.currentActiveItem;
            const pointerBottom = pointerTop + itemHeight;

            return {
                height: itemHeight,
                distance: {
                    top: pointerTop,
                    bottom: pointerBottom
                }
            }
        },
        viewport() {
            return {
                top: this.$refs.results.scrollTop,
                bottom: this.$refs.results.offsetHeight + this.$refs.results.scrollTop
            }
        },
        goTo() {
            if (this.resultsNotEmpty) {
                const endpoint = this.filteredEndpoints[this.currentActiveItem];
                this.$router.push({name: 'cortex', params: {id: endpoint.id}}).catch(err => {/* throw */});
                this.close();
            }
        },
        debugPointer() {
            console.log('-----------------------------------');
            console.log('Viewport Top: ', this.viewport().top + 'px');
            console.log('Viewport Bottom: ', this.viewport().bottom + 'px');
            console.log('Scroll Top: ', this.$refs.results.scrollTop + 'px');
            console.log('Highlighted item (top): ', this.highlightedItem().distance.top + 'px -- (distance)');
            console.log('Highlighted item (bottom): ', this.highlightedItem().distance.bottom + 'px -- (distance)');
            console.log('-----------------------------------');
        }
    }
}
</script>

<template>
    <div v-show="$root.spotlight.open">
        <transition name="modal">
            <div class="flex items-start justify-center z-50 fixed inset-0 overflow-y-auto modal-mask">
                <div class="outline-none my-10 modal-container" aria-modal="true" tabindex="-1">
                    <div class="spotlight-search-container">
                        <div class="spotlight-search-contents">
                            <div class="spotlight-search-bar">
                                <div class="flex items-center py-4 pl-3 rounded-t-lg bg-white">
                                    <div class="pointer-events-none mr-3">
                                        <svg class="fill-current pointer-events-none text-gray-400 w-3 h-3" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12.6 11.2c.037.028.073.059.107.093l3 3a1 1 0 1 1-1.414 1.414l-3-3a1.009 1.009 0 0 1-.093-.107 7 7 0 1 1 1.4-1.4zM7 12A5 5 0 1 0 7 2a5 5 0 0 0 0 10z" fill-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input
                                        ref="spotlightSearchInput"
                                        class="spotlight-search-input"
                                        type="text"
                                        placeholder="Type to search"
                                        autocomplete="off"
                                        @input="updateQuery($event.target.value)"
                                        @keydown.down.prevent="pointerDown()"
                                        @keydown.up.prevent="pointerUp()"
                                        @keypress.enter.prevent.stop.self="goTo()">
                                </div>
                            </div>
                            <div v-if="query && !filteredEndpoints.length" class="spotlight-search-results-empty">
                                No results
                            </div>
                            <div v-if="resultsNotEmpty" class="spotlight-search-results" ref="results">
                                <div class="px-2 pt-2">
                                    <!-- <div class="uppercase text-xs font-medium text-gray-500 ml-1 mb-2">Results</div> -->
                                    <router-link
                                        v-for="(endpoint, index) in filteredEndpoints"
                                        :key="index"
                                        :to="{name:'cortex', params:{id: endpoint.id}}"
                                        :class="currentActiveItem==index ? 'text-gray-100 bg-primary' : 'text-gray-500'"
                                        class="flex items-center justify-between rounded-lg p-2 cursor-pointer no-underline outline-none"
                                        tabindex="-1"
                                        ref="item"
                                        @mouseenter.native="onPointedItem(index)"
                                        @click.native="close">

                                        <div class="w-full text-xs leading-5 overflow-hidden mr-3 font-normal">
                                            <div class="mb-1">
                                                <span :class="{'text-gray-600': currentActiveItem!=index}" class="font-medium uppercase">
                                                    {{ endpoint.method }}
                                                </span>
                                                <span class="capitalize">
                                                    —  {{ endpoint.title }}
                                                </span>
                                            </div>
                                            <div v-show="currentActiveItem==index" class="capitalize font-normal truncate">
                                                <span :class="endpoint.description ? '' : 'italic'">
                                                    {{ endpoint.description || 'No description available' }}
                                                </span>
                                            </div>
                                        </div>
                                        <div>
                                            <svg :class="{'text-gray-400': currentActiveItem!=index}" class="fill-current w-3 h-3" style="transform: scaleY(-1);" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.5 5a5 5 0 0 1 0 10 1 1 0 0 1 0-2 3 3 0 0 0 0-6l-6.586-.007L6.45 9.528a1 1 0 0 1-1.414 1.414L.793 6.7a.997.997 0 0 1 0-1.414l4.243-4.243A1 1 0 0 1 6.45 2.457L3.914 4.993z" fill-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                     </router-link>
                                </div>
                            </div>
                            <div class="spotlight-search-footer">
                                <div class="flex">
                                    <div class="flex items-center mr-4">
                                        <svg class="fill-current pointer-events-none text-gray-500" style="width: 10px;height: 10px;" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 3.417V15a1 1 0 0 1-2 0V3.417L2.409 8.008A1 1 0 0 1 .993 6.593l6.3-6.3a1 1 0 0 1 1.414 0l6.3 6.3a1 1 0 0 1-1.416 1.415z" fill-rule="evenodd"></path>
                                        </svg>
                                        <svg class="fill-current pointer-events-none text-gray-500" style="width: 10px;height: 10px;" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 12.583l4.591-4.591a1 1 0 0 1 1.416 1.415l-6.3 6.3a1 1 0 0 1-1.414 0l-6.3-6.3A1 1 0 0 1 2.41 7.992L7 12.583V1a1 1 0 1 1 2 0z" fill-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1">Navigate</span>
                                    </div>
                                    <div class="flex items-center mr-4">
                                        <svg class="fill-current pointer-events-none text-gray-500" style="width: 10px;height: 10px; transform: scaleY(-1);" height="16" viewBox="0 0 16 16" width="16" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.5 5a5 5 0 0 1 0 10 1 1 0 0 1 0-2 3 3 0 0 0 0-6l-6.586-.007L6.45 9.528a1 1 0 0 1-1.414 1.414L.793 6.7a.997.997 0 0 1 0-1.414l4.243-4.243A1 1 0 0 1 6.45 2.457L3.914 4.993z" fill-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-1">Return</span>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    Press
                                    <kbd class="font-mono mx-2 border border-gray-200 rounded shadow-sm inline-block align-middle font-semibold text-gray-600" style="padding: 3px 5px;">
                                        esc
                                    </kbd>
                                    to exit
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
