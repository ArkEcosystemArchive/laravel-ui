export default class ErrorBag {
    #defaultBagName = 'default';

    /**
     * @param {string|null} bag
     */
    constructor(bag = null) {
        this.collection = {};

        if (!bag) {
            this.#defaultBagName = bag;
        }
    }

    /**
     * @param {string| null} key
     * @param {any} value
     * @param {string} bag
     * @return {void}
     */
    add(key = null, value = null, bag = this.#defaultBagName) {
        if (!key && !value) {
            this.collection[bag] = [];
            return;
        }

        this.#addItem(key, value, bag);
    }

    /**
     * @param {string} bag
     * @return {void}
     */
    reset(bag = this.#defaultBagName) {
        this.add(bag);
    }

    /**
     * @param {string|null} key
     * @param {string} bag
     * @return {Object[]|any}
     */
    get(key = null, bag = this.#defaultBagName) {
        if (!key) {
            return this.#getBag(bag);
        }

        return this.collection[bag].find(obj => obj.key === key);
    }

    /**
     * @param {string|null} key
     * @param {string} bag
     * @return {boolean}
     */
    hasErrors(key = null, bag = this.#defaultBagName) {
        if (!key) {
            return !!this.#getBag(bag).length;
        }

        return !!this.collection[bag].find(obj => obj.key === key);
    }

    /**
     * @param {string|null} key
     * @param {string} bag
     * @return {void}
     */
    remove(key = null, bag = this.#defaultBagName) {
        if (!key) {
            delete this.collection[bag];
            return;
        }

        const _bag = this.collection[bag];

        _bag.splice(_bag.findIndex(obj => obj.key === key), 1);
    }

    /**
     * @return {any|Object}
     */
    getAll() {
        return this.collection;
    }

    /**
     * @return {void}
     */
    resetAll() {
        this.collection = {};
    }

    /**
     * @return {ErrorBag}
     */
    unify() {
        const newCollection = {};

        Object.entries(this.collection).forEach(bags => {
            bags[1].forEach(bag => {
                let tmp, i = 0;
                const unique = bag.map(a => Object.assign({}, a)), repeat = [];

                while (i < bag.length) {
                    repeat.indexOf(tmp = bag[i].value) > -1
                        ? unique.splice(i, 1)
                        : repeat.push(tmp);
                    i++;
                }

                newCollection[bags[0]] = unique;
            });
        });

        this.collection = newCollection;

        return ErrorBag;
    }

    /**
     * @param {string} bag
     * @return {Object[]}
     */
    #getBag(bag = this.#defaultBagName) {
        return this.collection[bag];
    }

    /**
     * @param {string} key
     * @param {any} value
     * @param {string} bag
     * @return {void}
     */
    #addItem(key, value, bag = this.#defaultBagName) {
        this.#getBag(bag).push(ErrorBag.#errorItem(key, value));
    }

    /**
     * @param {string} key
     * @param {any} value
     * @return {Object<{value, key}>}
     */
    static #errorItem(key, value) {
        return {key: key, value: value};
    }
}
