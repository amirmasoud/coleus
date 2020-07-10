context('Navigation', () => {
  it('lands on home', () => {
    cy.visit('/')
    cy.url().should('match', /^/)
  })

  it('lands on books', () => {
    cy.visit('books')
    cy.url().should('match', /books/)
  })

  it('lands on profile', () => {
    cy.visit("Parvin-E'tesami")
    cy.url().should('match', /Parvin-E'tesami|Parvin-E%27tesami/)
  })

  it('lands on page', () => {
    cy.visit("Parvin-E'tesami/Divan---E-Parvin-E'Tesami/1/2/?page=1")
    cy.url().should(
      'match',
      /Parvin-E'tesami\/Divan---E-Parvin-E'Tesami\/1\/2\/\?page=1|Parvin-E%27tesami\/Divan---E-Parvin-E%27Tesami\/1\/2\/\?page=1/
    )
  })

  it('lands on 404', () => {
    cy.request({ method: 'GET', url: '404', failOnStatusCode: false }).then(
      (response) => {
        expect(response.status).to.eq(404)
      }
    )
  })
})
