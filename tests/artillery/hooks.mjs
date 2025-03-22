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
export function checkCheckout(req, res, context, ee, next) {
  console.log('Checkout response status:', res.statusCode);
  console.log('Checkout response body:', res.body);

  if (res.statusCode === 201 && res.body.includes('"success":true')) {
    console.log('Checkout successful!');
  } else {
    console.error('Checkout failed!');
  }
  return next();
}

