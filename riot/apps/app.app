<header>
  <nav><a each={ data } href="#{ id }">{ title }</a></nav>

  <article>
    <h1>{ page.title || 'Not found' }</h1>
    <p>{ page.body || 'Specified id is not found.' }</p>
  </article>

  <script>
    var self = this
    self.data = [
      { id: "", title: "Home", body: "Click the link above." },
      { id: "test", title: "First", body: "This is the first page." },
      { id: "test2", title: "Second", body: "This is the second page." }
    ]
    self.page = self.data[0]

    route(function(id) {
      self.page = self.data.filter(function(r) { return r.id == id })[0] || {}
      self.update()
    })
	console.log(ajax)
  </script>

  <style>
    :scope {
      display: block;
      font-family: sans-serif;
      margin: 0;
      padding: 1em;
      text-align: center;
      color: #f00;
    }
    nav {
      display: block;
      border-bottom: 1px solid #666;
      padding: 0 0 1em;
    }
    nav > a {
      display: inline-block;
      padding: 0 .8em;
    }
    nav > a:not(:first-child) {
      border-left: 1px solid #eee;
    }
  </style>
</header>
