<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-text leading-tight">
            {{ __('System Documentation') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-surface rounded-2xl shadow-sm border border-border overflow-hidden">
                <div class="bg-primary px-8 py-10 text-white">
                    <h3 class="text-3xl font-extrabold mb-3">Welcome to the BGBR Portal</h3>
                    <p class="text-white/90 text-lg max-w-2xl leading-relaxed">
                        A practical guide to understanding how our platform works and how you can manage your daily duties within the Brigade.
                    </p>
                </div>

                <div class="p-8 md:p-10 text-text">
                    <p class="text-lg mb-8 leading-relaxed text-muted">
                        If you're new to the Boys and Girls Brigade Management Portal, you might be wondering where to start. 
                        This page breaks down how our organization is structured online and how you can handle your tasks, 
                        whether you're a Company Captain, a Battalion Commander, or a Regional Administrator.
                    </p>

                    <div class="space-y-12">
                        <!-- Section 1 -->
                        <section>
                            <h3 class="text-2xl font-bold text-text mb-4 border-b border-border pb-2">1. The Chain of Command</h3>
                            <p class="mb-4 text-muted">Everything in the system mirrors our real-world structure. Here is how the groups flow from top to bottom:</p>
                            
                            <div class="bg-background rounded-xl p-5 border border-border">
                                <ul class="space-y-4">
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">1</div>
                                        <div>
                                            <strong class="text-text block mb-1">Denominations</strong>
                                            <span class="text-sm text-muted">This is the highest level. Every group belongs to a specific denomination.</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">2</div>
                                        <div>
                                            <strong class="text-text block mb-1">Zones</strong>
                                            <span class="text-sm text-muted">Large regions within a denomination are split into Zones.</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">3</div>
                                        <div>
                                            <strong class="text-text block mb-1">Battalions</strong>
                                            <span class="text-sm text-muted">Zones are broken down into Battalions. If you are a Battalion Commander, you oversee multiple companies in your area.</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">4</div>
                                        <div>
                                            <strong class="text-text block mb-1">Companies</strong>
                                            <span class="text-sm text-muted">This is the heart of the Brigade. It's the local unit at your church or school. Company Captains manage the activities and members here.</span>
                                        </div>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <div class="w-6 h-6 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">5</div>
                                        <div>
                                            <strong class="text-text block mb-1">Members</strong>
                                            <span class="text-sm text-muted">The individual boys, girls, and officers who make up a company.</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </section>

                        <!-- Section 2 -->
                        <section>
                            <h3 class="text-2xl font-bold text-text mb-4 border-b border-border pb-2">2. Managing Your Members</h3>
                            <p class="text-muted leading-relaxed">
                                If you manage a Company or a Battalion, keeping your member list accurate is your main job. 
                                You can add new members directly into your company through the <strong>"Members"</strong> tab on the sidebar. 
                                When you add a member, you'll record their details and rank. This helps headquarters know exactly how many active members we have across the country.
                            </p>
                        </section>

                        <!-- Section 3 -->
                        <section>
                            <h3 class="text-2xl font-bold text-text mb-4 border-b border-border pb-2">3. Finances: Fees and Deposits</h3>
                            <p class="mb-4 text-muted">Money matters can be tricky, so the portal keeps it simple:</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="bg-background rounded-xl p-5 border border-border">
                                    <strong class="text-text block mb-2 text-lg">Registration Fees</strong>
                                    <p class="text-sm text-muted leading-relaxed">Every member needs to pay an annual registration fee to stay active. You can log these payments in the system. Once logged, an admin will review and approve the payment to officially mark the member as "active" for the year.</p>
                                </div>
                                <div class="bg-background rounded-xl p-5 border border-border">
                                    <strong class="text-text block mb-2 text-lg">Account Deposits</strong>
                                    <p class="text-sm text-muted leading-relaxed">When your company or battalion deposits money into the national or regional bank accounts, you record that deposit slip here. It acts as a digital receipt so headquarters can confirm the funds.</p>
                                </div>
                            </div>
                        </section>

                        <!-- Section 4 -->
                        <section>
                            <h3 class="text-2xl font-bold text-text mb-4 border-b border-border pb-2">4. Day-to-Day Operations</h3>
                            <p class="mb-4 text-muted">Beyond just tracking members and money, the portal handles your regular activities:</p>
                            
                            <ul class="space-y-4">
                                <li class="bg-background rounded-xl p-4 border border-border flex flex-col sm:flex-row gap-4">
                                    <div class="w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <div>
                                        <strong class="text-text">Material Requests</strong>
                                        <p class="text-sm text-muted mt-1">Need new uniforms, badges, or training manuals? Instead of calling headquarters, submit a "Material Request" through the sidebar. You can track the status of your order right from your dashboard.</p>
                                    </div>
                                </li>
                                <li class="bg-background rounded-xl p-4 border border-border flex flex-col sm:flex-row gap-4">
                                    <div class="w-10 h-10 rounded-full bg-success/10 text-success flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div>
                                        <strong class="text-text">Activities & Events</strong>
                                        <p class="text-sm text-muted mt-1">You can schedule training camps, parades, or meetings under "Activities". This lets you track who attended and helps you plan ahead.</p>
                                    </div>
                                </li>
                                <li class="bg-background rounded-xl p-4 border border-border flex flex-col sm:flex-row gap-4">
                                    <div class="w-10 h-10 rounded-full bg-cyan-500/10 text-cyan-500 flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div>
                                        <strong class="text-text">Reports</strong>
                                        <p class="text-sm text-muted mt-1 mb-2">No more paper reports. You can generate point-in-time snapshot reports directly through the system. Reports are saved historically and can be downloaded as PDFs at any time without changing retroactively.</p>
                                        <ul class="list-disc list-inside text-sm text-muted space-y-1">
                                            <li><strong>Battalion Reports:</strong> summarize membership, attendance, and activity stats for all companies within a battalion.</li>
                                            <li><strong>Financial Reports:</strong> compile all fee submissions and account deposits to give a financial overview.</li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </section>

                        <!-- Section 5 -->
                        <section>
                            <h3 class="text-2xl font-bold text-text mb-4 border-b border-border pb-2">5. User Roles and Approvals</h3>
                            <p class="text-muted leading-relaxed">
                                Because this portal contains important records, we don't just let anyone sign up and start clicking around. 
                                When someone creates a new account, they are put on a <strong>"Pending"</strong> list. An admin has to manually review their account and assign them a specific role (like "Company Officer" or "Battalion Commander").
                            </p>
                            <p class="text-muted leading-relaxed mt-3">
                                What you can see and do on the sidebar depends entirely on this role. For example, a Company Captain can't see another company's members, and only Admins can approve fee payments.
                            </p>
                        </section>
                    </div>

                    <div class="bg-primary/5 border border-primary/20 rounded-xl p-6 mt-12 text-center flex flex-col items-center justify-center gap-3">
                        <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-primary font-bold text-lg">Still have questions?</p>
                        <p class="text-muted text-sm max-w-md mx-auto">Reach out to your commanding officer or the IT support team if you need further assistance with the portal.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
