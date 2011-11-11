The node IDs (NIDs) in this directory are for the kiosk.

When retrieving content, the songs have enough information to display a page...but the picture books may need to make up to 3 requests.
  
  Picture book
  |
  +--> Picture entries
       |
       +--> Tagged pictures

1. The first request is to get the picture book.
2. The second request is to get the entries in the book.
3. The third request is to get each individual picture.
