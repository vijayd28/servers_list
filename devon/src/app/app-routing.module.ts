import { NgModule } from '@angular/core';

import { AppComponent } from "./app.component";
import { HttpClientModule } from "@angular/common/http";
import { Routes, RouterModule } from '@angular/router';
import { BrowserModule } from "@angular/platform-browser";
import { ApiService } from "./shared/services/api.service";
import { GlobalService } from "./shared/services/global.service";

const routes: Routes = [
    {
        path: '',
        // component: LayoutWideComponent,
        // children: [
        //     {
        //         path: 'list',
        //         component: CreateComponent,
        //     }
        // ]
    },
];

@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [RouterModule.forRoot(routes), BrowserModule, HttpClientModule],
  exports: [RouterModule],
  providers: [
      GlobalService,
      ApiService
  ]
})
export class AppRoutingModule { }
