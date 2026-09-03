// Minimal static server with HTTP Range support (needed for scrubbable <video>).
const http = require('http'), fs = require('fs'), path = require('path');
const root = __dirname, port = Number(process.argv[2] || 8766);
const types = { '.html': 'text/html; charset=utf-8', '.js': 'text/javascript', '.css': 'text/css', '.jpg': 'image/jpeg', '.jpeg': 'image/jpeg', '.png': 'image/png', '.svg': 'image/svg+xml', '.mp4': 'video/mp4', '.mov': 'video/quicktime', '.webm': 'video/webm', '.json': 'application/json', '.md': 'text/plain; charset=utf-8', '.txt': 'text/plain; charset=utf-8' };
http.createServer((req, res) => {
  const t0 = Date.now(); res.on('close', () => console.log(req.method, req.url, 'range=' + (req.headers.range || '-'), '->', res.statusCode, res.getHeader('content-range') || res.getHeader('content-length'), (Date.now() - t0) + 'ms'));
  let p = decodeURIComponent(new URL(req.url, 'http://x').pathname);
  if (p.endsWith('/')) p += 'index.html';
  const file = path.normalize(path.join(root, p));
  if (!file.startsWith(root)) { res.writeHead(403); return res.end(); }
  fs.stat(file, (err, st) => {
    if (err || !st.isFile()) {
      if (!err && st.isDirectory()) {
        return fs.readdir(file, (e, list) => { res.writeHead(200, { 'Content-Type': 'text/html' }); res.end('<ul>' + (list || []).map(f => `<li><a href="${path.posix.join(p, f)}">${f}</a></li>`).join('') + '</ul>'); });
      }
      res.writeHead(404); return res.end('not found');
    }
    const type = types[path.extname(file).toLowerCase()] || 'application/octet-stream';
    const range = req.headers.range;
    const headers = { 'Content-Type': type, 'Accept-Ranges': 'bytes', 'Cache-Control': 'no-cache' };
    if (range) {
      const m = /bytes=(\d*)-(\d*)/.exec(range);
      let start, end;
      if (!m[1]) { // suffix range: last N bytes
        const n = Math.min(Number(m[2]), st.size); start = st.size - n; end = st.size - 1;
      } else { start = Number(m[1]); end = m[2] ? Number(m[2]) : st.size - 1; }
      if (start >= st.size) { res.writeHead(416, { 'Content-Range': `bytes */${st.size}` }); return res.end(); }
      end = Math.min(end, st.size - 1);
      res.writeHead(206, { ...headers, 'Content-Range': `bytes ${start}-${end}/${st.size}`, 'Content-Length': end - start + 1 });
      return fs.createReadStream(file, { start, end }).pipe(res);
    }
    res.writeHead(200, { ...headers, 'Content-Length': st.size });
    fs.createReadStream(file).pipe(res);
  });
}).listen(port, () => console.log('serving ' + root + ' on http://localhost:' + port));
