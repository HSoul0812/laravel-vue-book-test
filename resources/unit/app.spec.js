import { mount } from '@vue/test-utils'
import App from '../components/App'

describe('App Vue', () => {
  let wrapper

  beforeEach(() => {
    wrapper = mount(App)
  })

  test('renders properly', async () => {
    expect(wrapper.html()).toMatchSnapshot()
  })

})
