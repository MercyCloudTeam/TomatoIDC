import React, { Component } from 'react';
import { Provider } from 'react-redux';
import {BrowserRouter,Route } from 'react-router-dom';
import store from './store';
import { Globalstyle } from './style';
import IndexPage from './pages/index';

class App extends Component {
    render() {
        return (
            <Provider store={store}>
                <BrowserRouter>
                    <div>
                        <Globalstyle />
                        <Route path='/' exact component={IndexPage} />
                    </div>
                </BrowserRouter>
            </Provider>
        );
    }
}

export default App;
