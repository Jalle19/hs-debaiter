import type {PageLoad} from "./$types";

export const load: PageLoad = async ({fetch, params}) => {
    const response = await fetch(`http://localhost:8080/article/${params.guid}`)
    const article = await response.json()

    return {article}
}