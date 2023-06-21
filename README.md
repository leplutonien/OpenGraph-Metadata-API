# OpenGraph Metadata API
The OpenGraph Metadata API is a simple PHP-based API that retrieves OpenGraph metadata from a given URL. It allows you to extract relevant information such as title, description, and image for a specific webpage.
## Usage
To use the API, make a GET request to the following endpoint:
https://your-domain.com/api/open-graph?url={URL}

Replace `{URL}` with the URL you want to retrieve OpenGraph metadata from. The API will return a JSON response containing the extracted metadata.

Example response:

```json
{
  "title": "Example Page Title",
  "description": "Example page description.",
  "image": "https://example.com/image.jpg"
}
```
If there are any errors or if the URL is invalid, the API will return an appropriate error message in the response.

## Getting Started
To run the OpenGraph Metadata API locally or deploy it to your server, follow these steps:

1. Clone this repository:
git clone  https://github.com/leplutonien/OpenGraph-Metadata-API.git

2. Upload the files to your server or set up a local development environment.

3. Configure your server to handle PHP files.

4. Access the API using the endpoint mentioned above.

<p align="center">
	<a href="https://og-api.mogoulola.bj">Demo Page</a>&nbsp;&nbsp;&nbsp;	
</p>
