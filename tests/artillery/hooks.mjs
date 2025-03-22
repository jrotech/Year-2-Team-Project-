export function extractLaravelSession(req, res, context, ee, next) {
  console.log("✅ extractLaravelSession triggered");

  const cookieHeader = res.headers['set-cookie'];
  if (cookieHeader) {
    const session = cookieHeader.find(c => c.startsWith('laravel_session='));
    if (session) {
      context.vars.sessionCookie = session.split(';')[0];
    }
  }
  return next();
}
