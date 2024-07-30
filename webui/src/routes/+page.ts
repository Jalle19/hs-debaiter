import type {PageLoad} from "./$types";

export const load: PageLoad = async ({ fetch }) => {
    // Fetch articles
    let response = await fetch(`http://localhost:8080/articles`)
    const articles = await response.json()

    // Fetch frequently changed articles
    response = await fetch(`http://localhost:8080/articles/frequently-changed`)
    const frequentlyChangedArticles = await response.json()

    return { articles, frequentlyChangedArticles }
}